import {useGetPostsQuery} from '../../services/posts-service.js'

export const PostsPaginatorView = () => {

    const {data, error, isLoading} = useGetPostsQuery()

    console.log('Is Loading: ', isLoading)
    console.log('Error: ', error)
    console.dir('Data: ', data)

    return (
        <>
            <div className='mt-24'>
                {
                    data?.map((post) => (<h3>{post.title}</h3>))
                }
            </div>
        </>
    )
}
