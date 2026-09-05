# Deploy secrets (GitHub Environments: staging / production)
#
# App:
#   APP_BASE_URL, DB_HOSTNAME, DB_DATABASE, DB_USERNAME, DB_PASSWORD
#   JWT_SECRET, ENCRYPTION_KEY
#
# SSH:
#   DEPLOY_HOST, DEPLOY_USER, DEPLOY_SSH_KEY, DEPLOY_PATH, DEPLOY_PORT
#
# FTP (used only when DEPLOY_HOST is empty):
#   FTP_SERVER, FTP_USERNAME, FTP_PASSWORD, FTP_SERVER_DIR
#
# Flow:
#   Pipeline (main/master) → CI (tests) → Build (artifact) → Deploy
#   Deploy is skipped unless CI and Build both succeed.
