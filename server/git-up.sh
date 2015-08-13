#!/bin/bash
set -eu
SCRIPT_DIR="$(cd "$(dirname "$0")" && pwd)"

BASE_DIR=/var/www/yiiframework
SUDO_USER='sudo -u www-data -H'
GIT="$SUDO_USER /usr/bin/git"

cd $BASE_DIR

# update
$GIT fetch

CURRENT_TAG=`$GIT describe`
LATEST_TAG=`$GIT for-each-ref --sort=taggerdate --format="%(refname:short)" refs/tags | tail -1`
echo "Current tag: $CURRENT_TAG, latest tag: $LATEST_TAG"

if [ "$LATEST_TAG" != "$CURRENT_TAG" ]; then
    echo "Changes:"
    $GIT --no-pager log $CURRENT_TAG..$LATEST_TAG --stat --pretty=format:'%h:%C(green)%an, %C(white)%ar: %C(yellow)%s%C(white)' | less -Re
    echo ""

    read -p "Show changes as diff (y/n)? "
    if [ "$REPLY" == "y" ]; then
        $GIT diff $CURRENT_TAG..$LATEST_TAG | enscript --color --language=ansi --style=a2ps --highlight=diffu -o - -q - | less -Re
    fi

    read -p "Checkout tag $LATEST_TAG (y/n)? "
    if [ "$REPLY" == "y" ]; then
        $GIT checkout tags/$LATEST_TAG
    else
        echo "Not updated."
    fi
else
    echo "Nothing to update."
fi
