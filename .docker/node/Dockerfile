FROM node:22-alpine

# Puppeteer/Chromium potřebuje tyto knihovny
RUN apk add --no-cache \
      chromium nss freetype harfbuzz ca-certificates \
      udev ttf-freefont

ENV PUPPETEER_EXECUTABLE_PATH=/usr/bin/chromium-browser
WORKDIR /app
