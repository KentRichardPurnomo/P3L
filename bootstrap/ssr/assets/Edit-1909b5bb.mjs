import { j as jsxs, a as jsx } from "../ssr.mjs";
import { A as Authenticated } from "./AuthenticatedLayout-a06873bd.mjs";
import DeleteUserForm from "./DeleteUserForm-47ef68f1.mjs";
import UpdatePasswordForm from "./UpdatePasswordForm-72417c63.mjs";
import UpdateProfileInformation from "./UpdateProfileInformationForm-dc02a45d.mjs";
import { Head } from "@inertiajs/react";
import "react/jsx-runtime";
import "react-dom/server";
import "@inertiajs/react/server";
import "react";
import "./ApplicationLogo-f5319d5c.mjs";
import "@headlessui/react";
import "./TextInput-2ecbad64.mjs";
import "./InputLabel-ea80803f.mjs";
import "./PrimaryButton-e0cba7f6.mjs";
function Edit({ auth, mustVerifyEmail, status }) {
  return /* @__PURE__ */ jsxs(
    Authenticated,
    {
      auth,
      header: /* @__PURE__ */ jsx("h2", { className: "font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight", children: "Profile" }),
      children: [
        /* @__PURE__ */ jsx(Head, { title: "Profile" }),
        /* @__PURE__ */ jsx("div", { className: "py-12", children: /* @__PURE__ */ jsxs("div", { className: "max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6", children: [
          /* @__PURE__ */ jsx("div", { className: "p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg", children: /* @__PURE__ */ jsx(
            UpdateProfileInformation,
            {
              mustVerifyEmail,
              status,
              className: "max-w-xl"
            }
          ) }),
          /* @__PURE__ */ jsx("div", { className: "p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg", children: /* @__PURE__ */ jsx(UpdatePasswordForm, { className: "max-w-xl" }) }),
          /* @__PURE__ */ jsx("div", { className: "p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg", children: /* @__PURE__ */ jsx(DeleteUserForm, { className: "max-w-xl" }) })
        ] }) })
      ]
    }
  );
}
export {
  Edit as default
};
