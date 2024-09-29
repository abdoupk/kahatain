module.exports = {
    env: {
        browser: true,
        es2021: true,
        'vue/setup-compiler-macros': true
    },
    extends: [
        'plugin:vue/vue3-essential',
        'eslint:recommended',
        'plugin:@typescript-eslint/recommended',
        'plugin:@typescript-eslint/eslint-recommended',
        'plugin:cypress/recommended',
        '@vue/eslint-config-typescript',
        'prettier'
    ],
    parser: 'vue-eslint-parser',
    parserOptions: {
        tsconfigRootDir: __dirname,
        project: ['./tsconfig.json', './tests/cypress/e2e/tsconfig.json'],
        extraFileExtensions: ['.vue'],
        ecmaVersion: 'latest',
        sourceType: 'module',
        // files: ['tests/cypress/**/*.{ts,tsx,mts,cts}'],
        parser: {
            ts: '@typescript-eslint/parser',
            '<template>': 'espree'
        }
    },
    overrides: [],
    plugins: ['vue', 'prettier', 'cypress'],
    rules: {
        'no-console': 'warn',
        'capitalized-comments': ['error', 'always'],
        'vue/multi-word-component-names': [
            'error',
            {
                ignores: [
                    'Register',
                    'Login',
                    'Checkbox',
                    'Dropdown',
                    'Modal',
                    'Dashboard',
                    'Edit',
                    'Welcome'
                ]
            }
        ],
        'padding-line-between-statements': [
            'error',
            {
                blankLine: 'always',
                prev: '*',
                next: '*'
            },
            {
                blankLine: 'any',
                prev: '*',
                next: ['export', 'import']
            }
        ],
        '@typescript-eslint/ban-ts-comment': 'off',
        // 'sort-imports': [
        //     'warn'
        // ],
        'array-element-newline': [
            'error',
            {
                multiline: true,
                minItems: 3
            }
        ]
    },
    ignorePatterns: ['.eslintrc.cjs',
        'vite.config.ts',
        'cypress.config.ts',
        'vitest.config.ts',
        'resources/js/*.ts',
        'resources/js/Components/Base/dropzone/index.ts',
        'resources/js/generated/**/*.*',
        'resources/js/utils/*.ts',
        'resources/js/types/*.d.ts',
        'resources/js/types/*.ts']
}
