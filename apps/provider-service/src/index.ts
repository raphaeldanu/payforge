import express from "express";
import pino from "pino";
import { pinoHttp } from "pino-http";

const app = express();
const logger = pino();

const port = Number(process.env.PORT ?? 3001);

app.use(express.json());
app.use(pinoHttp({ logger }));

app.get("/health", (_req, res) => {
  res.status(200).json({
    success: true,
    service: "payforge-provider-service",
    status: "healthy",
  });
});

app.listen(port, "0.0.0.0", () => {
  logger.info(`Provider service listening on port ${port}`);
});
