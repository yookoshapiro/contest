import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

// https://vitejs.dev/config/
export default defineConfig(({ command, mode }) => {

  // Entwicklung, etc.
  return {
    plugins: [vue()],
    build: {
      outDir: "../public",
      assetsInlineLimit: 0,
    }
  }

})
