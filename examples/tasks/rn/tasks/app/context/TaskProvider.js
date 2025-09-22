import { createContext, useReducer, useContext } from "react";

/* ------------------------------------------------------------------ */
/* ---------------------------  MODEL ------------------------------- */
/* ------------------------------------------------------------------ */
export const Task = ({ id, name, description, isUrgent, isDone }) => ({
  id,
  name,
  description,
  isUrgent,
  isDone,
});

/* ------------------------------------------------------------------ */
/* --------------------------  STATE -------------------------------- */
/* ------------------------------------------------------------------ */
const TaskContext = createContext();

const initialState = {
  tasks: [],
};

function taskReducer(state, action) {
  switch (action.type) {
    case "ADD_TASK":
      return { tasks: [...state.tasks, action.payload] };

    case "UPDATE_TASK":
      return {
        tasks: state.tasks.map((t) =>
          t.id === action.payload.id ? action.payload : t
        ),
      };

    case "REMOVE_TASK":
      return { tasks: state.tasks.filter((t) => t.id !== action.payload) };

    default:
      return state;
  }
}

/* ------------------------------------------------------------------ */
/* -------------------------  PROVIDER ------------------------------ */
/* ------------------------------------------------------------------ */
export const TaskProvider = ({ children }) => {
  const [state, dispatch] = useReducer(taskReducer, initialState);

  /* id generator: first available positive integer */
  const firstAvailableId = () => {
    if (!state.tasks.length) return 1;
    const ids = new Set(state.tasks.map((t) => t.id));
    let i = 1;
    while (ids.has(i)) i++;
    return i;
  };

  /* CRUD helpers */
  const addTask = (task) => dispatch({ type: "ADD_TASK", payload: task });
  const updateTask = (task) => dispatch({ type: "UPDATE_TASK", payload: task });
  const removeTask = (id) => dispatch({ type: "REMOVE_TASK", payload: id });

  return (
    <TaskContext.Provider
      value={{
        tasks: state.tasks,
        addTask,
        updateTask,
        removeTask,
        firstAvailableId,
      }}
    >
      {children}
    </TaskContext.Provider>
  );
};

/* ------------------------------------------------------------------ */
/* ----------------------------  HOOK ------------------------------- */
/* ------------------------------------------------------------------ */
export const useTaskContext = () => useContext(TaskContext);