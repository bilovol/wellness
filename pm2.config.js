const APP_BASE_PATH = process.env.APP_BASE_PATH;
const CONSUMERS_LOG_PATH = `${process.env.APP_BASE_PATH}/storage/logs/pm2`;

module.exports = {
    apps: [
        {
            name: "payment",
            script: `${APP_BASE_PATH}/artisan`,
            interpreter: "/usr/local/bin/php",
            args: "wellness:payment",
            cwd: APP_BASE_PATH,
            instances: 1,
            cron_restart: "00 00 * * *",
            exec_mode: "fork",
            max_memory_restart: "100M",
            autorestart: false,
            log_date_format: "YYYY-MM-DD HH:mm:ss",
            merge_logs: true,
            error_file: `/dev/null`,
            out_file: `${CONSUMERS_LOG_PATH}/wellness.out.log`,
            user: 'www-data'
        }
    ]
};
