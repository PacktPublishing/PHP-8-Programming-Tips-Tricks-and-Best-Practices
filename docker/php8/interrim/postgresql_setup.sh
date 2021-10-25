#!/bin/bash
echo "Finishing Apache setup ..."
echo "Adding sample data to PostgreSQL ..."
/etc/init.d/postgresql start
sleep 5
su postgres
psql -c "CREATE DATABASE php8_tips;"
psql -d php8_tips -f /tmp/pgsql_users_create.sql
