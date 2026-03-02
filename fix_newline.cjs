const fs = require('fs');
const path = require('path');

const modelsDir = path.join(__dirname, 'app', 'Models');
const files = fs.readdirSync(modelsDir);

files.forEach(file => {
    if (file.endsWith('.php')) {
        const filePath = path.join(modelsDir, file);
        let content = fs.readFileSync(filePath, 'utf8');

        if (content.includes('\\nuse Illuminate\\Database\\Eloquent\\Factories\\HasFactory;')) {
            content = content.replace(
                '\\nuse Illuminate\\Database\\Eloquent\\Factories\\HasFactory;',
                '\nuse Illuminate\\Database\\Eloquent\\Factories\\HasFactory;'
            );
            fs.writeFileSync(filePath, content);
            console.log('Fixed literal \\n in ' + file);
        }
    }
});
