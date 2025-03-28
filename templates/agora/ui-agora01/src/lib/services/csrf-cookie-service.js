import { createApi, fetchBaseQuery } from '@reduxjs/toolkit/query/react'
import ENV from '../env/env'

export const csrfCookieApi = createApi({
    reducerPath: 'csrfCookieApi',
    baseQuery: fetchBaseQuery({
        baseUrl: ENV.baseCsrfCookieUrl
    }),
    endpoints: (builder) => ({
        // This query requires csrf-cookie:
        getCsrfCookie: builder.query({
            query: () => "csrf-cookie"
        }),
    })
})

// Please note: { use`getCsrfCookie`Query } => `useGetCsrfCookieQuery`
export const { useGetCsrfCookieQuery } = csrfCookieApi
