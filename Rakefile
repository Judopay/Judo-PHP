task :doc do
  Rake::Task['doc:html'].invoke
end

namespace :doc do
  task :html do
    sh 'phpdoc -d ./src -t ./doc'
  end

  task :xml do
    sh 'phpdoc -d ./src -t ./doc  --template="xml"'
  end
end

task :test do
  sh './bin/phpspec run'
end

namespace :code do
  task :sniff do
    sh 'bin/phpcs --standard=.phpcs.xml src'
  end
end