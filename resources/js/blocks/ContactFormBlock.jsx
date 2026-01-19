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

    function submit(e) {
        e.preventDefault();
        post("/contact", {
            onSuccess: () => reset(),
        });
    }

    return (
        <form
            onSubmit={submit}
            className="w-full max-w-xl space-y-8 rounded-3xl bg-white p-10 shadow-lg"
        >
            {/* Header */}
            <div className="space-y-3">
                <h1
                    className={`text-3xl font-semibold tracking-tight ${theme.text.primary}`}
                >
                    {title}
                </h1>
                <p className="text-sm text-gray-600">{description}</p>

                {flash?.success && (
                    <div className="rounded-lg bg-green-50 px-4 py-3 text-sm text-green-700">
                        {flash.success}
                    </div>
                )}
            </div>

            {/* Name */}
            <div className="flex flex-col gap-2">
                <label className="text-sm font-medium text-gray-700">
                    Name
                </label>
                <input
                    type="text"
                    value={formData.name}
                    onChange={(e) => setData("name", e.target.value)}
                    className={`w-full rounded-xl bg-gray-100 px-4 py-3 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-200 ${
                        errors.name ? "ring-red-200" : ""
                    }`}
                    placeholder="Enter your name"
                />
                {errors.name && (
                    <p className="text-xs text-red-600">{errors.name}</p>
                )}
            </div>

            {/* Email */}
            <div className="flex flex-col gap-2">
                <label className="text-sm font-medium text-gray-700">
                    Email
                </label>
                <input
                    type="email"
                    value={formData.email}
                    onChange={(e) => setData("email", e.target.value)}
                    className={`w-full rounded-xl bg-gray-100 px-4 py-3 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-200 ${
                        errors.email ? "ring-red-200" : ""
                    }`}
                    placeholder="Enter your email"
                />
                {errors.email && (
                    <p className="text-xs text-red-600">{errors.email}</p>
                )}
            </div>

            {/* Message */}
            <div className="flex flex-col gap-2">
                <label className="text-sm font-medium text-gray-700">
                    Message
                </label>
                <textarea
                    rows={5}
                    value={formData.message}
                    onChange={(e) => setData("message", e.target.value)}
                    className={`w-full rounded-xl bg-gray-100 px-4 py-3 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-200 ${
                        errors.message ? "ring-red-200" : ""
                    }`}
                    placeholder="Write your message"
                />
                {errors.message && (
                    <p className="text-xs text-red-600">{errors.message}</p>
                )}
            </div>

            {/* Submit */}
            <button
                type="submit"
                disabled={processing}
                className="inline-flex w-full items-center justify-center rounded-xl bg-blue-600 px-5 py-3 text-sm font-medium text-white transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 disabled:cursor-not-allowed disabled:opacity-60"
            >
                {processing ? "Sending..." : "Send message"}
            </button>
        </form>
    );
}
