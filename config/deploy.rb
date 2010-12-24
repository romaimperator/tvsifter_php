require 'rubygems'
require 'railsless-deploy'
#load 'config/deploy'

set :application, "tvsifter.com"
set :repository,  "git@github.com:romaimperator/tvsifter.git"
set :branch, "master"
set :scm, :git

set :shared_children, %w(cache logs)

set :deploy_to, "/home/deploy/#{application}/"
set :deploy_via, :remote_cache
set :user, "deploy"

set :cakephp_app_path, 'app'
set :cakephp_core_path, 'cake'

set :use_sudo, false
set :keep_releases, 5
set :copy_exlude, ['.git', '.gitignore']
#set :copy_compression, :gzip

ssh_options[:forward_agent] = true

server "tvsifter.com", :app, :web, :db, :primary => true

#task :production do
    #after "deploy:finalize_update" #, "deploy:cakephp:testsuite"
#end

#before "deploy:update", 'deploy:web:disable'
#after 'deploy:restart', 'deploy:web:enable'
#after 'deploy:update', 'deploy:cleanup'

namespace :deploy do
    
    desc "This is here to override the original :restart"
    task :restart, :roles => :app do
        # do nothing but override the default because we don't need to restart a RoR app
        clear_cache
    end

    task :finalize_update, :roles => :app do
        # link a custom configuration file for environment specifics
        #run "ln -s #{deploy_to}/#{shared_dir}/bootstrap.remote.php #{release_path}/#{cakephp_app_path}/config/bootstrap.remote.php"

        # you may link here upload file folders if you have any, which should
        # be placed in #{deploy_to}/#{shared_dir} which won't be overriden on
        # each deployment
        
        #override the rest of the default method

        # link cake
        run "ln -s #{shared_path}/cakephp #{current_release}/cake"

        # link config files
        run "rm -rf #{current_release}/app/config/core.php"
        run "ln -s #{shared_path}/config/core.php #{current_release}/app/config/core.php"
        run "ln -s #{shared_path}/config/database.php #{current_release}/app/config/database.php"

        # link the tmp
        run "rm -rf #{current_release}/app/tmp"
        run "ln -s #{shared_path}/tmp #{current_release}/app/tmp"
    end

    namespace :web do
        desc "lock the current access during deployment"
        task :disable, :roles => :app do
            run "touch #{current_release}/#{cakephp_app_path}/webroot/.capistrano-lock"
        end

        desc "enable the current access after deployment"
        task :enable, :roles => :app do
            run "rm #{current_release}/#{cakephp_app_path}/webroot/.capistrano-lock"
        end
    end

    namespace :cakephp do
        desc 'verify cakephp testsuite pass'
        task :testsuite, :roles => :app do
            run "#{release_path}/#{cakephp_cake_path}/console/cake testsuite app all -app #{release_path}/#{cakephp_app_path}", :env => { :TERM => 'linux' } do |channel, stream, data|
                if stream == :err then
                    error = CommandError.new('CakePHP TestSuite failed')
                    raise error
                else
                    puts data
                end
            end
        end
    end

    namespace :clear_cache do
        desc <<-DESC
            Blow up all the cache files Cakephp uses, ensuring a clean restart.
        DESC

        task :default do
            run "rm -rf #{shared_path}/tmp/*"

            #run "mkdir -p #{shared_path}/tmp/{cache/{models,persistent,views},sessions,logs,tests}"
            run "mkdir -p #{shared_path}/tmp/cache"
            run "mkdir -p #{shared_path}/tmp/cache/models"
            run "mkdir -p #{shared_path}/tmp/cache/cacheable"
            run "mkdir -p #{shared_path}/tmp/cache/persistent"
            run "mkdir -p #{shared_path}/tmp/cache/views"
            run "mkdir -p #{shared_path}/tmp/sessions"
            run "mkdir -p #{shared_path}/tmp/logs"
            run "mkdir -p #{shared_path}/tmp/tests"
            run "chmod -R 766 #{shared_path}/tmp"
        end
    end
end


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

#capcake
