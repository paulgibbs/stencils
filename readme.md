# Stencils for WordPress

Requirements
------------
Install [Node.js](http://nodejs.org/) and the [Grunt CLI](http://gruntjs.com/getting-started).

* **Install Node.js:** You can [download and install the package](http://nodejs.org/) or use a package manager, like [Homebrew](http://brew.sh/).
* **Install the Grunt CLI:** After installing Node, run `npm install -g grunt-cli` in your shell.


Getting Started
---------------
Once you've installed Node.js and the Grunt CLI, you're ready to get started.

1. Clone this repository in a directory of your choice by running `git clone https://github.com/paulgibbs/stencils.git`.
2. Navigate to the directory in your shell.
3. Run `npm install`.


Documentation
-------------

The `src` directory contains the Stencils' plugin core files. You can develop against the `src` directory like you normally would develop against any other WordPress plugins' SVN trunk.

### `grunt` or `grunt build-dev`
Generates the development-optimised source in the `src` directory.

### `grunt build-prod`
Generates the production-optimised source in the `build` directory.

### `grunt clean:all`
Removes the `build` directory.
