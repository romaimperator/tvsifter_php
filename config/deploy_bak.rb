require 'rubygems'
require 'capcake'

set :application, "tvsifter"
set :repository,  "git@github.com:romaimperator/tvsifter.git"

set :scm, :git
# Or: `accurev`, `bzr`, `cvs`, `darcs`, `git`, `mercurial`, `perforce`, `subversion` or `none`

set :user, "deploy"
set :scm_passphrase, "threeKINGSisAWESOME"

ssh_options[:forward_agent] = true

set :branch, "master"

set :deploy_via, :remote_cache

server "tvsifter.com", :app, :db, :primary => true

role :app, "tvsifter.com"
role :web, "tvsifter.com"

#set :shared_children, %w(config tmp)
set :cake_branch, "1.3.6"

#task :production do
    set :deploy_to, '/home/deploy/'
#end

# If you are using Passenger mod_rails uncomment this:
# if you're still using the script/reapear helper you will need
# these http://github.com/rails/irs_process_scripts

# namespace :deploy do
#   task :start {}
#   task :stop {}
#   task :restart, :roles => :app, :except => { :no_release => true } do
#     run "#{try_sudo} touch #{File.join(current_path,'tmp','restart.txt')}"
#   end
# end

capcake
