// Do this as the first thing so that any code reading it knows the right env.
process.env.BABEL_ENV = "test";
process.env.NODE_ENV = "test";
process.env.PUBLIC_URL = "";

process.on("unhandledRejection", (err) => {
    throw err;
});

const jest = require("jest");
// eslint-disable-next-line one-var
const argv = process.argv.slice(2);

jest.run(argv);
