import { useState, useEffect } from "react";
import axios from "axios";
import ENV from "../env";

const PostRead = () => {
  const BASE_URL = ENV.baseUrl;
  const [post, setPost] = useState("");
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
        await axios.get("sanctum/csrf-cookie").then((res) => {
          console.log(res.data);
        });
        await axios.get("api/post/50").then((res) => {
          console.log(res.data);
          setPost(res.data);
          setLoading(false);
        });
      } catch (error) {
        console.log(error);
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
          <h3 className="uppercase">{post.title}</h3>
          <p>{post.content}</p>
          <hr />
          <h3>{post.user}</h3>
          <p>{post.email}</p>
          <hr />
          <h5>response status: {post.status}</h5>
        </div>
      )}
    </div>
  );
};

export default PostRead;
