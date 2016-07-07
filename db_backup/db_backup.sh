mysql -u 'it_crowd' -h localhost 'it_crowd' --execute "SELECT * FROM meal_planner" --bat > ~/workspace/db_backup/meal_planner.txt
mysql -u 'it_crowd' -h localhost 'it_crowd' --execute "SELECT * FROM users" --bat > ~/workspace/db_backup/users.txt
mysql -u 'it_crowd' -h localhost 'it_crowd' --execute "SELECT * FROM recipe" --bat > ~/workspace/db_backup/recipe.txt
mysql -u 'it_crowd' -h localhost 'it_crowd' --execute "SELECT * FROM ingredient" --bat > ~/workspace/db_backup/ingreient.txt
mysql -u 'it_crowd' -h localhost 'it_crowd' --execute "SELECT * FROM ingredient_subhead" --bat > ~/workspace/db_backup/ingredient_subhead.txt
mysql -u 'it_crowd' -h localhost 'it_crowd' --execute "SELECT * FROM method" --bat > ~/workspace/db_backup/method.txt