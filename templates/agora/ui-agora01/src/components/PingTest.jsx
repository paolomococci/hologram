import { useState, useEffect } from "react";
import { LoaderCircle } from "lucide-react";
import axios from "axios";
import ENV from "../env";

const PingTest = () => {
  const BASE_URL = ENV.baseUrl;
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
        <p>
          <LoaderCircle className="w-20 h-20 text-orange-400 animate-[spin_1s_ease-in-out_infinite]" />
        </p>
      ) : error ? (
        <p className="text-red-400">{error}</p>
      ) : (
        <div>
          <p className="text-slate-400">{message}</p>
        </div>
      )}
    </div>
  );
};

export default PingTest;
