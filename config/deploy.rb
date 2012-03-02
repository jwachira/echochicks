set :user, "admin"
set :repository, "git@github.com:chai2/fs_blog.git"
set :scm, :git
set :deploy_to, "/var/www/apps/fashionsprout_blog/"

set :deploy_via, :remote_cache
set :copy_exclude, [".git", ".DS_Store", ".gitignore", ".gitmodules"]

server "staging.fashionsprout.com", :app
