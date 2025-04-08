FROM node:20.18.1
 
WORKDIR /app
 
# Copy only package.json and package-lock.json first
COPY package*.json ./
 
# Install fresh dependencies for Linux
RUN rm -rf node_modules package-lock.json && npm install
 
# Now copy the rest of your app
COPY . .
 
# Expose dev port
EXPOSE 5173
 
# Start Vite
CMD ["npm", "run", "dev", "--", "--host"]