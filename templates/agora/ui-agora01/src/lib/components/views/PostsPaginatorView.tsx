import { useGetPostsQuery } from '../../services/posts-service.ts'
import { Loader } from 'lucide-react'

export const PostsPaginatorView = () => {

    const { data, error, isLoading } = useGetPostsQuery()

    console.log('Is Loading: ', isLoading)
    console.log('Error: ', error)
    console.dir('Data: ', data)

    if (!Array.isArray(data)) {
        return (
            <>
                <div>
                    <Loader color="#fc08" size={64} className='md:size-20 lg:size-28 animate-[spin_1s_ease-in-out_infinite]' />
                </div>
            </>
        )
    } else {
        return (
            <>
                <div className='mt-32'>
                    {data?.map((post) => <div key={post.id}>{post.title}</div>)}
                </div>
            </>
        )
    }
}
