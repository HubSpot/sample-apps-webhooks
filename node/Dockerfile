FROM node:18.17.0

WORKDIR /app
COPY ./package.json /app/
COPY ./package-lock.json /app/
RUN npm install

EXPOSE 3000
