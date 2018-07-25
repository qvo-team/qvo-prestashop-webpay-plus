#!/bin/bash

echo -e "Please enter output module name: \c "
read release_name

if [ ! -d "releases" ]; then
  mkdir releases
fi

if [ -f releases/$release_name.zip ]
  then
  rm releases/$release_name.zip
fi

rsync -a --exclude='.*' . ./qvoprestashopwebpayplus/

zip -r releases/$release_name.zip qvoprestashopwebpayplus/ -x "qvoprestashopwebpayplus/releases/*" "qvoprestashopwebpayplus/assets-ps-repo/*" ".git/*" "qvoprestashopwebpayplus/generate_release.sh"

rm -rf qvoprestashopwebpayplus/
