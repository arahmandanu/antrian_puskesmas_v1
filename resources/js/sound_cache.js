const CACHE_NAME = "sound-cache";
const urlParams = new URL(self.location).searchParams;
const BASE_URL = urlParams.get("baseUrl");
const AUDIO_BASE_URL = `${BASE_URL}/sound/`;
// Huruf A-Z
const letters = Array.from({ length: 26 }, (_, i) => String.fromCharCode(65 + i));

// Angka 0-9
const numbers = Array.from({ length: 10 }, (_, i) => String(i));

// Gabungkan
const alphanumeric = [...letters, ...numbers];

const ASSETS_TO_CACHE = [];
alphanumeric.forEach(element => {
    ASSETS_TO_CACHE.push(`${AUDIO_BASE_URL}${element}.mp3`)
});

function sendMessageToClients(msg) {
    self.clients.matchAll({ includeUncontrolled: true }).then((clients) => {
        clients.forEach(client => client.postMessage(msg));
    });
}

self.addEventListener("install", (event) => {
    event.waitUntil((async () => {
        const cache = await caches.open(CACHE_NAME);
        let loaded = 0;

        for (let file of ASSETS_TO_CACHE) {
            const match = await cache.match(file);
            if (!match) {
                console.log(cache, "Caching file:", file);
                try {
                    const response = await fetch(file, { cache: "no-cache" });
                    if (response.ok) await cache.put(file, response.clone());
                } catch (err) {
                    console.error("Gagal cache:", file, err);
                }
            }
            loaded++;
            sendMessageToClients({ type: "CACHE_PROGRESS", loaded, total: ASSETS_TO_CACHE.length });
        }

        sendMessageToClients({ type: "CACHE_DONE" });
    })());

    self.skipWaiting();
});

self.addEventListener("activate", (event) => {
    event.waitUntil(clients.claim());
});

self.addEventListener("message", async (event) => {
    if (event.data?.type === "CHECK_CACHE") {
        console.log(event.data?.type);
        const cache = await caches.open(CACHE_NAME);
        const keys = await cache.keys();
        sendMessageToClients({ type: "CACHE_PROGRESS", loaded: keys.length, total: ASSETS_TO_CACHE.length });
        if (keys.length >= ASSETS_TO_CACHE.length) sendMessageToClients({ type: "CACHE_DONE" });
    }
});
