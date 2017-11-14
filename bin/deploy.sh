#!/usr/bin/env bash

# if [[ "false" != "$TRAVIS_PULL_REQUEST" ]]; then
#     echo "Not deploying pull requests."
#     exit
# fi
echo "_|＼○_ﾋｬｯ ε=＼＿○ﾉ ﾎｰｳ!!"
if [[ "dist_test" != "$TRAVIS_BRANCH" ]]; then
    echo "Not on the 'master' branch."
    exit
fi

set -e

## -b オプションはチェックアウト
git clone -b dist --quiet "https://github.com/${TRAVIS_REPO_SLUG}.git" dist
npm run dist
cd dist
## すべての変更を含むワークツリーの内容をインデックスに追加.
git add -A
git commit -m "Update from travis $TRAVIS_COMMIT"
echo "_|＼○_ﾋｬｯ ε=＼＿○ﾉ ﾎｰｳ!! 2"
git push --quiet "https://${GH_TOKEN}@github.com/${TRAVIS_REPO_SLUG}.git" dist 2> /dev/null
echo "_|＼○_ﾋｬｯ ε=＼＿○ﾉ ﾎｰｳ!! 3"
