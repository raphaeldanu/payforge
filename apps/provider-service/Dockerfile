FROM node:22-alpine

WORKDIR /app

COPY apps/provider-service/package*.json ./

RUN npm ci

COPY apps/provider-service/ ./

EXPOSE 3001

CMD ["npm", "run", "dev"]
