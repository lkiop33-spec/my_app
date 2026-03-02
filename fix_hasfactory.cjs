const fs = require('fs');
const path = require('path');

const modelsDir = path.join(__dirname, 'app', 'Models');
const files = fs.readdirSync(modelsDir);

files.forEach(file => {
    if (file.endsWith('.php')) {
        const filePath = path.join(modelsDir, file);
        let content = fs.readFileSync(filePath, 'utf8');

        // Check if HasFactory is used but not imported
        if (content.includes('use HasFactory;') && !content.includes('use Illuminate\\Database\\Eloquent\\Factories\\HasFactory;')) {
            // Find where to insert it - right before or after use Illuminate\Database\Eloquent\Model;
            if (content.includes('use Illuminate\\Database\\Eloquent\\Model;')) {
                content = content.replace(
                    'use Illuminate\\Database\\Eloquent\\Model;',
                    'use Illuminate\\Database\\Eloquent\\Model;\\nuse Illuminate\\Database\\Eloquent\\Factories\\HasFactory;'
                );
                fs.writeFileSync(filePath, content);
                console.log('Fixed ' + file);
            }
        }
    }
});
