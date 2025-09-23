const CACHE_NAME = "sound-cache";
let cachingFinished = false; // track if caching is done
let cachingPromise = null;   // track install process
const urlParams = new URL(self.location).searchParams;
const BASE_URL = urlParams.get("baseUrl");
const AUDIO_BASE_URL = `${BASE_URL}/sound/`;

// Huruf A-Z
const letters = Array.from({ length: 26 }, (_, i) => String.fromCharCode(65 + i));
// Angka 0-9
const numbers = Array.from({ length: 10 }, (_, i) => String(i));
const custom = [
    'akupresur', 'bpu', 'caten', 'farmasi', 'gigi', 'haji', 'ims', 'jiwa gizi',
    'lab', 'lansia', 'loket', 'mtbs', 'nomor_antrian', 'pkpr', 'poli',
    'polijiwagizi', 'psikolog', 'ptm', 'ruang', 'silahkan_menuju', 'surveilans'
];
// Gabungkan
const alphanumeric = [...letters, ...numbers, ...custom];

// Daftar asset
const ASSETS_TO_CACHE = alphanumeric.map(el => `${AUDIO_BASE_URL}${el}.mp3`);

function sendMessageToClients(msg) {
    self.clients.matchAll({ includeUncontrolled: true }).then((clients) => {
        clients.forEach(client => client.postMessage(msg));
    });
}

self.addEventListener("install", (event) => {
    cachingPromise = (async () => {
        const cache = await caches.open(CACHE_NAME);

        for (let i = 0; i < ASSETS_TO_CACHE.length; i++) {
            const file = ASSETS_TO_CACHE[i];
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

            // report based on index, so max = total
            sendMessageToClients({
                type: "CACHE_PROGRESS",
                loaded: i + 1,
                total: ASSETS_TO_CACHE.length
            });
        }

        // Apapun hasilnya, tetap kirim selesai
        cachingFinished = true;
        sendMessageToClients({ type: "CACHE_DONE" });
    })();

    event.waitUntil(cachingPromise);
    self.skipWaiting();
});

self.addEventListener("activate", (event) => {
    event.waitUntil(clients.claim());
});

self.addEventListener("message", async (event) => {
    if (event.data?.type === "CHECK_CACHE") {
        const cache = await caches.open(CACHE_NAME);
        const keys = await cache.keys();

        // Always report progress
        sendMessageToClients({
            type: "CACHE_PROGRESS",
            loaded: Math.min(keys.length, ASSETS_TO_CACHE.length),
            total: ASSETS_TO_CACHE.length
        });

        if (cachingFinished) {
            sendMessageToClients({ type: "CACHE_DONE" });
        } else if (cachingPromise) {
            cachingPromise.then(() => {
                sendMessageToClients({ type: "CACHE_DONE" });
            });
        }
    }
});
