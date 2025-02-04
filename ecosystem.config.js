module.exports = {
    apps: [
        {
            name: 'Kahatain',
            script: 'artisan',
            args: ['inertia:start-ssr', '--runtime=bun'],
            instances: 1,
            wait_ready: true,
            autorestart: true,
            max_restarts: 10,
            interpreter: 'php',
            watch: true,
            error_file: 'log/err.log',
            out_file: 'log/out.log',
            log_file: 'log/combined.log',
            time: true
        }
    ]
}
