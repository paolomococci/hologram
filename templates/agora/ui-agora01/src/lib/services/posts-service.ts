import { createApi, fetchBaseQuery } from '@reduxjs/toolkit/query/react'
import type Posts from '../interfaces/posts'
import type Post from '../interfaces/post'
import Paginator from '../interfaces/paginator'
import ENV from '../env/env'

export const jsonApiPosts = createApi({
    reducerPath: 'jsonApiPosts',
    baseQuery: fetchBaseQuery({
        baseUrl: ENV.baseApiUrl
    }),
    endpoints: (build) => ({
        // This query requires all posts:
        getPosts: build.query<Posts, void>({
            query: () => "posts"
        }),
        // This is the query that requires a specific post:
        getPost: build.query<Post, number>({
            query: (id) => `posts/${id}`
        }),
        // This is the query that requires pagination with an optional search filter:
        getPaginatePosts: build.query<Posts, Paginator>({
            query: ({page, sieve}) => `paginate/${page}?filter=${sieve}`
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
