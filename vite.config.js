import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import { fileURLToPath, URL } from "node:url";
import { quasar, transformAssetUrls } from "@quasar/vite-plugin";

export default defineConfig({
    plugins: [
        vue({
            template: { transformAssetUrls },
        }),
        laravel({
            input: ["resources/css/app.css", "resources/ts/src/main.ts"],
            refresh: true,
        }),
        quasar({
            autoImportComponentCase: "kebab",
            sassVariables: "./resources/ts/src/quasar-variables.sass",
        }),
    ],
    resolve: {
        alias: {
            "@": fileURLToPath(new URL("./resources/ts/src", import.meta.url)),
        },
    },
});
