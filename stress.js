import { check, sleep } from 'k6'
import { SharedArray } from 'k6/data'
import http from 'k6/http'

// Load test users from a static array (can be from an external file)
const users = new SharedArray('users', function () {
    return [
        { username: 'test@example.com', password: 'password' },
        { username: 'test2@example.com', password: 'password' },
        { username: 'test3@example.com', password: 'password' }
    ]
})

// Load test options with gradual ramp-up
export let options = {
    stages: [
        { duration: '2m', target: 20 }, // Warm-up phase (20 users)
        { duration: '3m', target: 50 }, // Ramp-up phase (100 users)
        { duration: '5m', target: 100 }, // Peak load (313 users)
        { duration: '3m', target: 13 } // Cool-down phase
    ]
}

export default function () {
    let user = users[__VU % users.length] // Assign user based on VU index

    // Step 1: Login Request
    let loginRes = http.post('https://test.kahatain-dz.com/login', JSON.stringify(user), {
        headers: { 'Content-Type': 'application/json' }
    })

    check(loginRes, {
        'Login successful': (res) => res.status === 200
    })

    // Extract and store session token if applicable
    let authToken = loginRes.headers['Authorization'] // Change based on your API response

    let headers = authToken ? { Authorization: `Bearer ${authToken}` } : {}

    // Step 2: Access Protected Dashboard
    let dashboardRes = http.get('https://test.kahatain-dz.com/dashboard', { headers })

    check(dashboardRes, {
        'Dashboard accessed': (res) => res.status === 200
    })

    // Simulate real user behavior with random pauses
    sleep(Math.random() * 3 + 1) // Sleep between 1s to 4s
}
