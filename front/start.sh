#!/bin/bash

if ! [ -d "node_modules" ]; then
    echo "Installing dependencies"

    npm install
fi

if [ -e ".env" ]; then
    echo ".env file already exists"
else
    echo "Creating .env file"
    cp .env.example .env
fi

npm run dev
