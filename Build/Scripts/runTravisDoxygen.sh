#!/usr/bin/env bash

# see https://benlimmer.com/2013/12/26/automatically-publish-javadoc-to-gh-pages-with-travis-ci/
# [ "$TRAVIS_REPO_SLUG" == "thucke/TYPO3.ext.th_rating" ]
# We want this to only happen from our repo, not forks.
# Since people will clone this script when they fork the repo, we don’t want them to be able to publish doc
# if they set up Travis. Luckily, our secret GITHUB_TOKEN variable will not work for their fork, but we might as well
# bail from the script if it’s not our repo.

# [ "$TRAVIS_PULL_REQUEST" == "false" ]
# Building pull requests is pretty awesome, we want to make sure that people have pushed solid code before we merge it in. However, we don’t want documentation to be published until we merge it.

# [ "$TRAVIS_BRANCH" == "master" ]
# If it’s merged to master, we want to publish doc for it.

# Go to the directory this script is located, so everything else is relative
# to this dir, no matter from where this script is called.
THIS_SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null && pwd )"
cd "$THIS_SCRIPT_DIR"

if [ "$TRAVIS_REPO_SLUG" == "thucke/TYPO3.ext.th_rating" ] && [ "$TRAVIS_PULL_REQUEST" == "false" ] && [ "$TRAVIS_BRANCH" == "doxygen" ]; then
    set -x

    mkdir -p $HOME/build/doxygen
    #copy current doxygen configuration to statix place
    cp ../.doxygen $HOME/build/doxygen

    # Get to the Travis build directory, configure git and clone the repo
    pushd $HOME/build
    #git config --global user.email "travis@travis-ci.org"
    #git config --global user.name "travis-ci"
    git clone --branch=gh-pages https://${GITHUB_TOKEN}@github.com/thucke/TYPO3.ext.th_rating.git gh-pages

    # cleanup documentation
    git rm -rf gh-pages/*

    # generate new documentation
    cd doxygen
    doxygen .doxygen
    mv -f html/* $HOME/build/gh-pages

    # Commit and Push the Changes
    cd $HOME/build/gh-pages
    git add -f .
    git commit -m "Latest doxygen generated doc on successful travis build $TRAVIS_BUILD_NUMBER auto-pushed to gh-pages"
    git push -fq origin gh-pages

    echo -e "Published Doxygen html to gh-pages.\n"

    popd
fi
