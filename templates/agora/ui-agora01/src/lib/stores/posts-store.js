import { configureStore } from "@reduxjs/toolkit"
import { setupListeners } from "@reduxjs/toolkit/query"
import { jsonApiPosts } from "../services/posts-service.js"

export const postsStore = configureStore({
  reducer: {
    [jsonApiPosts.reducerPath]: jsonApiPosts.reducer,
  },
  middleware: (getDefaultMiddleware) => getDefaultMiddleware().concat(jsonApiPosts.middleware),
})

setupListeners(postsStore.dispatch)
