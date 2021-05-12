FROM ruby:2.6.3
RUN apt-get update -qq && apt-get install -y mariadb-client nodejs

RUN mkdir /hubspot-api-client

ADD ./ /hubspot-api-client

WORKDIR /hubspot-api-client
RUN gem install bundler
RUN bundle install

# Add a script to be executed every time the container starts.
COPY ./docker-entrypoint.sh /usr/bin/
RUN chmod +x /usr/bin/docker-entrypoint.sh
ENTRYPOINT ["docker-entrypoint.sh"]
EXPOSE 3000

# Start the main process.
CMD ["rails", "server", "-b", "0.0.0.0"]
