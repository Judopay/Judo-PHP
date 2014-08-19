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