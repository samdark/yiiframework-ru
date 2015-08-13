#!/bin/bash
set -eu
SCRIPT_DIR="$(cd "$(dirname "$0")" && pwd)"

BASE_DIR=/var/www/yiiframework
SUDO_USER='sudo -u www-data -H'
GIT="$SUDO_USER /usr/bin/git"
cd $BASE_DIR
$GIT pull
