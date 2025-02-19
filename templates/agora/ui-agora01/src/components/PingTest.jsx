import { useState, useEffect } from "react";
import axios from "axios";

const PingTest = () => {
  const BASE_URL="https://api-agora01.hologram-srv.local/";
  const [message, setMessage] = useState("");
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
        await axios.get("api/ping").then((res) => {
          console.log(res);
          setMessage(res.data.message);
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
          <p>{message}</p>
        </div>
      )}
    </div>
  );
};

export default PingTest;
