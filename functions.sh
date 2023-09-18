command_exists() {
    command -v "$@" >/dev/null 2>&1
}

node_latest() {
    # nodejs and npm  related stuff
    # Ref:- https://nodejs.dev/learn/update-all-the-nodejs-dependencies-to-their-latest-version
    #npm i  npm-check-updates node-sass
    npm install
    # ./node_modules/.bin/ncu -u OR npx npm-check-updates -u
    npm update
    ${SUDO} chmod -R a+x node_modules
    ${SUDO} chmod -R +x ./node_modules/.bin
    npm rebuild node-sass
}