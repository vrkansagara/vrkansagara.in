#!/usr/bin/env bash
set -ex # This setting is telling the script to exit on a command error.
if [[ "$1" == "-v" ]]; then
  set -x # You refer to a noisy script.(Used to debugging)
fi
shopt -s extglob

GREEN=$'\e[0;32m'
RED=$'\e[0;31m'
NC=$'\e[0m'

export PWD="$(cd "$(dirname "${BASH_SOURCE[0]}")" &>/dev/null && pwd)"
echo "Change current directory to $PWD"
cd $PWD

export DEBIAN_FRONTEND=noninteractive
export CURRENT_DATE=$(date "+%Y%m%d%H%M%S")

echo "$GREEN Script started at $CURRENT_DATE $NC"

if [ "$(whoami)" != "root" ]; then
  SUDO=sudo
fi

# """""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""
#  Maintainer :- Vallabh Kansagara<vrkansagara@gmail.com> — @vrkansagara
#  Ref:- bash init.sh --mvc VrkansagaraIn
# """""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

projectName=$2
echo "Julia web application start creating using Genie [ $projectName]"

runProduction() {
  if sudo lsof -t -i:80; then sudo kill -9 $(sudo lsof -t -i:80); fi
  export GENIE_ENV=prod
  cd $PWD/blog
  julia --project=. --banner=no --eval="using Pkg; using Genie; Genie.Generator.write_secrets_file()"
  ${SUDO} chmod +x ./bin/*
  ${SUDO} ./bin/server
}

run() {
  export GENIE_ENV=dev
  cd $PWD/blog
  julia --project=. --banner=no --eval="using Pkg;using Test;"
  ${SUDO} chmod +x ./bin/*
  ${SUDO} ./bin/server
}

service() {
  cd $PWD
  echo "Generating Service project => $projectName"
  julia --eval "using Genie; Genie.Generator.newapp_webservice(\"$projectName\")"
}
mvc() {
  cd $PWD
  echo "Generating MVC project => $projectName"
  julia --eval "import Pkg; Pkg.add("\"Genie\""); "
  julia --eval "using Genie; Genie.Generator.newapp_mvc(\"$projectName\")"
}

main() {
  if [[ "$1" == "--service" ]]; then
    service
  fi
  if [[ "$1" == "--mvc" ]]; then
    mvc
  fi

  if [[ "$1" == "--run" ]]; then
    run
  fi

  if [[ "$1" == "--runProduction" ]]; then
    runProduction
  fi
}

main "$@"