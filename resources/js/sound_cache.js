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

// Daftar asset
const ASSETS_TO_CACHE = alphanumeric.map(el => `${AUDIO_BASE_URL}${el}.mp3`);

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
            try {
                const match = await cache.match(file);
                if (!match) {
                    const response = await fetch(file, { cache: "no-cache" });
                    if (response.ok) {
                        await cache.put(file, response.clone());
                        console.log("✅ Cached:", file);
                    } else {
                        console.warn("⚠️ Gagal fetch:", file, response.status);
                    }
                }
            } catch (err) {
                console.error("❌ Error cache:", file, err);
            }

            loaded++;
            sendMessageToClients({ type: "CACHE_PROGRESS", loaded, total: ASSETS_TO_CACHE.length });
        }

        // Apapun hasilnya, tetap kirim selesai
        sendMessageToClients({ type: "CACHE_DONE" });
    })());

    self.skipWaiting();
});

self.addEventListener("activate", (event) => {
    event.waitUntil(clients.claim());
});

self.addEventListener("message", async (event) => {
    if (event.data?.type === "CHECK_CACHE") {
        const cache = await caches.open(CACHE_NAME);
        const keys = await cache.keys();
        sendMessageToClients({ type: "CACHE_PROGRESS", loaded: keys.length, total: ASSETS_TO_CACHE.length });
        sendMessageToClients({ type: "CACHE_DONE" });
    }
});
