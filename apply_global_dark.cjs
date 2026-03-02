const fs = require('fs');
const path = require('path');

const directories = [
    'resources/views/layouts',
    'resources/views/components',
    'resources/views/posts',
    'resources/views/users',
    'resources/views/departments',
    'resources/views/notices'
];

const specificFiles = [
    'resources/views/dashboard.blade.php',
    'resources/views/geade.blade.php'
];

const replacements = [
    { from: /bg-white/g, to: 'bg-gray-800' },
    { from: /bg-gray-50/g, to: 'bg-gray-700' },
    { from: /bg-gray-100/g, to: 'bg-gray-900' },
    { from: /border-gray-100/g, to: 'border-gray-700' },
    { from: /border-gray-200/g, to: 'border-gray-700' },
    { from: /border-gray-300/g, to: 'border-gray-600' },
    { from: /text-gray-900(?!0)/g, to: 'text-white' },
    { from: /text-gray-800/g, to: 'text-white' },
    { from: /text-gray-700/g, to: 'text-gray-300' },
    { from: /text-gray-600/g, to: 'text-gray-400' },
    { from: /text-gray-500/g, to: 'text-gray-400' },
    { from: /hover:text-gray-700/g, to: 'hover:text-gray-300' },
    { from: /hover:text-gray-500/g, to: 'hover:text-gray-300' },
    { from: /hover:bg-gray-50/g, to: 'hover:bg-gray-700' },
    { from: /hover:bg-gray-100/g, to: 'hover:bg-gray-700' },
    { from: /focus:text-gray-700/g, to: 'focus:text-gray-300' },
    // Navigation specific
    { from: /border-indigo-400 text-sm font-medium leading-5 text-gray-900/g, to: 'border-indigo-400 text-sm font-medium leading-5 text-white' },
    { from: /border-indigo-400 text-base font-medium text-indigo-700 bg-indigo-50/g, to: 'border-indigo-400 text-base font-medium text-white bg-indigo-900/50' }
];

function processFile(filePath) {
    if (!fs.existsSync(filePath)) return;

    let original = fs.readFileSync(filePath, 'utf8');
    let content = original;

    replacements.forEach(({ from, to }) => {
        content = content.replace(from, to);
    });

    if (content !== original) {
        fs.writeFileSync(filePath, content);
        console.log(`Updated: ${filePath}`);
    }
}

function processDirectory(dirPath) {
    const fullDir = path.join(__dirname, dirPath);
    if (!fs.existsSync(fullDir)) return;

    const items = fs.readdirSync(fullDir);
    items.forEach(item => {
        const itemPath = path.join(fullDir, item);
        const stat = fs.statSync(itemPath);

        if (stat.isDirectory()) {
            processDirectory(path.join(dirPath, item));
        } else if (item.endsWith('.blade.php')) {
            processFile(itemPath);
        }
    });
}

directories.forEach(processDirectory);
specificFiles.forEach(file => processFile(path.join(__dirname, file)));

console.log('Global dark mode script finished.');
