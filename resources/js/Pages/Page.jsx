import React from "react";
import { Head } from "@inertiajs/react";
import Navigation from "../Components/Navigation";

export default function Page({ title }) {
    const menu = [
        {
            label: "About",
            path: "about",
            submenu: [
                {
                    label: "Executive Committee",
                    path: "about/executive-committee",
                },
                {
                    label: "Advisory Board",
                    path: "about/advisory-board",
                },
                {
                    label: "F.A.Q",
                    path: "about/faq",
                },
            ],
        },
        {
            label: "Announcements",
            path: "announcements",
            submenu: [
                {
                    label: "Call For Papers",
                    path: "announcements/call-for-papers",
                },
                {
                    label: "News",
                    path: "announcements/news",
                },
                {
                    label: "Upcoming Events",
                    path: "announcements/events",
                },
            ],
        },
        {
            label: "Research & Networks",
            path: "research-networks",
            submenu: [
                { label: "About", path: "research-networks/about" },
                { label: "Team / Governance", path: "research-networks/team" },
                { label: "Initiatives", path: "research-networks/initiatives" },
                {
                    label: "Member Directory",
                    path: "research-networks/member-directory",
                },
                { label: "Member Area", path: "research-networks/member-area" },
                {
                    label: "Resources / Outputs",
                    path: "research-networks/resources",
                },
            ],
        },
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
