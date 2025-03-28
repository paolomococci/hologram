import { createApi, fetchBaseQuery } from '@reduxjs/toolkit/query/react'
import ENV from '../env/env'

export const jsonApiPosts = createApi({
    reducerPath: 'jsonApiPosts',
    baseQuery: fetchBaseQuery({
        baseUrl: ENV.baseApiUrl
    }),
    endpoints: (builder) => ({
        // This query requires all posts:
        getPosts: builder.query({
            query: () => "posts"
        }),
        // This is the query that requires a specific post:
        getPost: builder.query({
            query: (id) => `posts/${id}`
        }),
        // This is the query that requires pagination with an optional search filter:
        getPaginatePosts: builder.query({
            query: (page, sieve) => `paginate/${page}?filter=${sieve}`
        }),
    })
})


// Please note: { use`getPosts`Query } => `useGetPostsQuery`
// Please note: { use`getPost`Query } => `useGetPostQuery`
// Please note: { use`getPaginatePosts`Query } => `useGetPaginatePostsQuery`
export const { 
    useGetPostsQuery, 
    useGetPostQuery,
    useGetPaginatePostsQuery
 } = jsonApiPosts
