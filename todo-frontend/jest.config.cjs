// jest.config.cjs
module.exports = {
  transform: {
    '^.+\\.js$': 'babel-jest',
    '^.+\\.vue$': 'vue-jest',
    '^.+\\.ts$': 'babel-jest', // Add transformation for TypeScript files (if using)
  },
  moduleNameMapper: {
    '^@/(.*)$': '<rootDir>/src/$1', // Maps '@' alias to the 'src' directory
  },
  transformIgnorePatterns: [
    '/node_modules/(?!axios)/', // Transforms files inside node_modules, specifically axios
  ],
};
