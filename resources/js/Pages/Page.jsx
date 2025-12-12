import React from "react";
import { Head } from "@inertiajs/react";
import Navigation from "../Components/Navigation";

export default function Page({ title }) {
    const menu = [
        {
            label: "About",
            path: "about",
            submenu: [{ label: "FAQ", path: "faq" }],
        },
        { label: "Announcements", path: "announcements" },
        { label: "Member Directory", path: "member-directory" },
        { label: "Member Area", path: "member-area" },
        {
            label: "Conferences",
            path: "conferences",
            submenu: [
                { label: "MAP 1 (2025)", path: "conferences/map-1-2025" },
                { label: "MAP 2 (2026)", path: "conferences/map-2-2026" },
                { label: "MAP 3 (2027)", path: "conferences/map-3-2027" },
            ],
        },
    ];

    return (
        <div>
            <Head title={title} />
            <Navigation menu={menu} />
            <h1>{title}</h1>
        </div>
    );
}
