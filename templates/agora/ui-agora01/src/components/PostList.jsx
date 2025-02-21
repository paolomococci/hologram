import { useState, useEffect } from "react";
import axios from "axios";
import ENV from "../env";

const PostList = () => {
  const BASE_URL = ENV.baseUrl;
  const [posts, setPosts] = useState([]);
  const [error, setError] = useState(null);
  const [loading, setLoading] = useState(true);

  axios.create({
    httpsAgent: {
      rejectUnauthorized: false,
      secureOptions: 0x2 | 0x4,
    },
  });
  axios.defaults.withCredentials = true;
  axios.defaults.withXSRFToken = true;
  axios.defaults.baseURL = BASE_URL;

  useEffect(() => {
    const fetchPosts = async () => {
      try {
        await axios.get("api/posts").then((res) => {
          console.log(res.data.posts);
          const posts = new Array();
          res.data.posts.forEach((post) => {
            const words = post.content.split(" ").filter(Boolean);
            const content = words.slice(0, 9).join(" ");
            post.content = content;
            posts.push(post);
          });
          setPosts(posts);
          setLoading(false);
        });
      } catch (error) {
        setError(error.message);
        setLoading(false);
      }
    };
    fetchPosts();
  }, []);

  return (
    <div className="p-3 m-3">
      {loading ? (
        <p>Please wait for the data loading…</p>
      ) : error ? (
        <p>{error}</p>
      ) : (
        <div>
          <ul>
            {posts.map((post) => (
              <li className="" key={post.id}>
                <h3 className="uppercase">
                  <a href="#">{post.title}</a>
                </h3>
                <p>{post.content}…</p>
                <p>author: {post.user.name}</p>
                <hr />
              </li>
            ))}
          </ul>
        </div>
      )}
    </div>
  );
};

export default PostList;
