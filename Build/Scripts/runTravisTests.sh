#!/usr/bin/env bash

#
# TYPO3 core test runner based on docker and docker-compose.
#

# Function to write a .env file in Build/testing-docker/local
# This is read by docker-compose and vars defined here are
# used in Build/testing-docker/local/docker-compose.yml
setUpDockerComposeDotEnv() {
    #before_install
    composer self-update
    composer --version

    #before_script
    phpenv config-rm xdebug.ini || echo "xdebug not available"
    composer require typo3/minimal=$TYPO3_VERSION
    # Restore composer.json
    git checkout composer.json
    export TYPO3_PATH_WEB=$PWD/.Build/Web
}

# Load help text into $HELP
read -r -d '' HELP <<EOF
th_rating test runner. Execute unit test suite and some other details.
Also used by travis-ci for test execution.

Successfully tested with docker version 18.06.1-ce and docker-compose 1.21.2.

Usage: $0 [options] [file]

No arguments: Run all unit tests with PHP 7.2

Options:
    -s <...>
        Specifies which test suite to run
            - acceptance: backend acceptance tests
            - composerInstall: "composer install", handy if host has no PHP, uses composer cache of users home
            - composerValidate: "composer validate"
            - functional: functional tests
            - lint: PHP linting
            - unit (default): PHP unit tests

    -d <mariadb|mssql|postgres|sqlite>
        Only with -s functional
        Specifies on which DBMS tests are performed
            - mariadb (default): use mariadb
            - mssql: use mssql microsoft sql server
            - postgres: use postgres
            - sqlite: use sqlite

    -p <7.2|7.3>
        Specifies the PHP minor version to be used
            - 7.2 (default): use PHP 7.2
            - 7.3: use PHP 7.3

    -e "<phpunit or codeception options>"
        Only with -s acceptance|functional|unit
        Additional options to send to phpunit (unit & functional tests) or codeception (acceptance
        tests). For phpunit, options starting with "--" must be added after options starting with "-".
        Example -e "-v --filter canRetrieveValueWithGP" to enable verbose output AND filter tests
        named "canRetrieveValueWithGP"

    -x
        Only with -s functional|unit
        Send information to host instance for test or system under test break points. This is especially
        useful if a local PhpStorm instance is listening on default xdebug port 9000. A different port
        can be selected with -y

    -y <port>
        Send xdebug information to a different port than default 9000 if an IDE like PhpStorm
        is not listening on default port.

    -u
        Update existing typo3gmbh/phpXY:latest docker images. Maintenance call to docker pull latest
        versions of the main php images. The images are updated once in a while and only the youngest
        ones are supported by core testing. Use this if weird test errors occur. Also removes obsolete
        image versions of typo3gmbh/phpXY.

    -v
        Enable verbose script output. Shows variables and docker commands.

    -h
        Show this help.

Examples:
    # Run unit tests using PHP 7.2
    ./Build/Scripts/runTests.sh

    # Run unit tests using PHP 7.3
    ./Build/Scripts/runTests.sh -p 7.3
EOF

# Go to the directory this script is located, so everything else is relative
# to this dir, no matter from where this script is called.
THIS_SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null && pwd )"

# Option parsing
# Reset in case getopts has been used previously in the shell
OPTIND=1
# Array for invalid options
INVALID_OPTIONS=();
# Simple option parsing based on getopts (! not getopt)
while getopts ":s:d:p:e:xy:hv" OPT; do
    case ${OPT} in
        s)
            TEST_SUITE=${OPTARG}
            ;;
        d)
            DBMS=${OPTARG}
            ;;
        p)
            PHP_VERSION=${OPTARG}
            ;;
        e)
            EXTRA_TEST_OPTIONS=${OPTARG}
            ;;
        x)
            PHP_XDEBUG_ON=1
            ;;
        y)
            PHP_XDEBUG_PORT=${OPTARG}
            ;;
        h)
            echo "${HELP}"
            exit 0
            ;;
        v)
            SCRIPT_VERBOSE=1
            ;;
        \?)
            INVALID_OPTIONS+=(${OPTARG})
            ;;
        :)
            INVALID_OPTIONS+=(${OPTARG})
            ;;
    esac
done

# Exit on invalid options
if [ ${#INVALID_OPTIONS[@]} -ne 0 ]; then
    echo "Invalid option(s):" >&2
    for I in "${INVALID_OPTIONS[@]}"; do
        echo "-"${I} >&2
    done
    echo >&2
    echo "${HELP}" >&2
    exit 1
fi

# Set $1 to first mass argument, this is the optional test file or test directory to execute
shift $((OPTIND - 1))
case ${TEST_SUITE} in
    acceptance)
        TEST_FILE="Web/typo3conf/ext/th_rating/Tests/Acceptance"
        ;;
    functional)
        TEST_FILE="Web/typo3conf/ext/th_rating/Tests/Functional"
        ;;
    unit)
        TEST_FILE="Web/typo3conf/ext/th_rating/Tests/Unit"
        ;;
esac

if [ ${SCRIPT_VERBOSE} -eq 1 ]; then
    set -x
fi

# Suite execution
case ${TEST_SUITE} in
    acceptance)
        setUpDockerComposeDotEnv
        ;;
    composerInstall)
        setUpDockerComposeDotEnv
        docker-compose run composer_install
        SUITE_EXIT_CODE=$?
        docker-compose down
        ;;
    composerValidate)
        setUpDockerComposeDotEnv
        docker-compose run composer_validate
        SUITE_EXIT_CODE=$?
        docker-compose down
        ;;
    functional)
        setUpDockerComposeDotEnv
        find 'Tests/Functional' -wholename '*Test.php' | parallel --gnu 'echo; echo "Running functional test suite {}"; .Build/bin/phpunit --colors  -c .Build/vendor/nimut/testing-framework/res/Configuration/FunctionalTests.xml {}'
        echo $PWD
        ;;
    lint)
        find . -name \*.php ! -path "./.Build/*" | parallel --gnu php -d display_errors=stderr -l {} > /dev/null \;
        ;;
    unit)
        setUpDockerComposeDotEnv
        .Build/bin/phpunit --colors -c .Build/vendor/nimut/testing-framework/res/Configuration/UnitTests.xml Tests/Unit/
        ;;
    php-cs-fixer)
        setUpDockerComposeDotEnv
        docker-compose run php-cs-fixer
        SUITE_EXIT_CODE=$?
        docker-compose down
        ;;
    *)
        echo "Invalid -s option argument ${TEST_SUITE}" >&2
        echo >&2
        echo "${HELP}" >&2
        exit 1
esac

exit $SUITE_EXIT_CODE

#convertDeprecationsToExceptions="false"

