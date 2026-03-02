const fs = require('fs');
const path = require('path');

const tables = [
    { model: 'Location', varName: 'location', viewFolder: 'locations' },
    { model: 'Part', varName: 'part', viewFolder: 'parts' },
    { model: 'Level', varName: 'level', viewFolder: 'levels' },
    { model: 'WorkList', varName: 'workList', viewFolder: 'work_lists' },
    { model: 'PcbTable', varName: 'pcbTable', viewFolder: 'pcb_tables' },
    { model: 'PartTable', varName: 'partTable', viewFolder: 'part_tables' },
    { model: 'ProcessTable', varName: 'processTable', viewFolder: 'process_tables' },
    { model: 'PcbImageTable', varName: 'pcbImageTable', viewFolder: 'pcb_image_tables' },
    { model: 'DocList', varName: 'docList', viewFolder: 'doc_lists' },
    { model: 'Type', varName: 'type', viewFolder: 'types' },
    { model: 'Language', varName: 'language', viewFolder: 'languages' },
    { model: 'Forbidden', varName: 'forbidden', viewFolder: 'forbiddens' },
    { model: 'Device', varName: 'device', viewFolder: 'devices' }
];

const basePath = path.join(__dirname, 'resources', 'views');

tables.forEach(table => {
    const editPath = path.join(basePath, table.viewFolder, 'edit.blade.php');
    const showPath = path.join(basePath, table.viewFolder, 'show.blade.php');

    [editPath, showPath].forEach(filePath => {
        if (fs.existsSync(filePath)) {
            let content = fs.readFileSync(filePath, 'utf8');

            // Replace `$item->` with `$tableName->` everywhere
            content = content.replace(/\$item->/g, `\$${table.varName}->`);

            fs.writeFileSync(filePath, content);
            console.log(`Updated: ${filePath}`);
        }
    });
});
