import { configureStore } from "@reduxjs/toolkit"
import { setupListeners } from "@reduxjs/toolkit/query"
import { csrfCookieApi } from "../services/csrf-cookie-service.ts"

export const csrfCookieStore = configureStore({
  reducer: {
    [csrfCookieApi.reducerPath]: csrfCookieApi.reducer
  },
  middleware: (getDefaultMiddleware) =>
    getDefaultMiddleware().concat(csrfCookieApi.middleware)
})

setupListeners(csrfCookieStore.dispatch)
