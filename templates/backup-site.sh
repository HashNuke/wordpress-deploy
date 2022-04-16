#!/usr/bin/env bash

export site_content_path="{{ site_content_path }}"
export site_backups_path="{{ site_backups_path }}"

export datestamp=$(date "+%Y-%m-%d")
export db_export_file="${datestamp}-db-export.sql"
export ext_backup_file="${datestamp}-ext.tar.gz"
export cleanroom_path="${site_backups_path}/.working-dir"

# Ensure to delete and recreate cleanroom
rm -rf ${cleanroom_path}
mkdir -p ${cleanroom_path}

# cd into wordpress dir and generate db backup file
cd ${site_content_path}
wp db export ${site_backups_path}/${db_export_file}

# Change to cleanroom for the backup
cd ${cleanroom_path}

# Copy the db export file
cp ${site_backups_path}/${db_export_file} ${cleanroom_path}/

# Copy the uploads dir into the cleanroom
cp -R ${site_content_path}/wp-content/uploads ${cleanroom_path}/

# Create the tar file outside the cleanroom
tar czvf ${site_backups_path}/${ext_backup_file} .

# Change to the backups dir
cd ${site_backups_path}

# Delete the cleanroom for the backup
rm -rf ${cleanroom_path}

echo "Database backup generated at ${site_backups_path}/${db_export_file}"
echo "Extended backup with database & uploads folder generated at ${site_backups_path}/${ext_backup_file}"
echo ""
