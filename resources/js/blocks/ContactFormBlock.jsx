import React from "react";
import { useForm, usePage } from "@inertiajs/react";

import { defaultTheme } from "@/config/theme";

export default function ContactFormBlock({ data, theme = defaultTheme }) {
    const { title, description } = data;

    const {
        data: formData,
        setData,
        post,
        processing,
        errors,
        reset,
    } = useForm({
        name: "",
        email: "",
        message: "",
    });

    const { flash } = usePage().props;

    console.log(flash);

    function submit(e) {
        e.preventDefault();
        post("/contact", {
            onSuccess: () => reset(),
        });
    }

    return (
        <form onSubmit={submit} className="space-y-4">
            <div>
                <h1 className={`text-3xl font-semibold ${theme.text.primary}`}>
                    {title}
                </h1>
                <p>{description}</p>
                {flash && flash.success && (
                    <div className="text-green-600">{flash.success}</div>
                )}
            </div>
            <div>
                <input
                    type="text"
                    placeholder="Name"
                    value={formData.name}
                    onChange={(e) => setData("name", e.target.value)}
                />
                {errors.name && (
                    <div className="text-red-500">{errors.name}</div>
                )}
            </div>

            <div>
                <input
                    type="email"
                    placeholder="Email"
                    value={formData.email}
                    onChange={(e) => setData("email", e.target.value)}
                />
                {errors.email && (
                    <div className="text-red-500">{errors.email}</div>
                )}
            </div>

            <div>
                <textarea
                    placeholder="Message"
                    value={formData.message}
                    onChange={(e) => setData("message", e.target.value)}
                />
                {errors.message && (
                    <div className="text-red-500">{errors.message}</div>
                )}
            </div>

            <button disabled={processing}>
                {processing ? "Sending..." : "Send"}
            </button>
        </form>
    );
}
