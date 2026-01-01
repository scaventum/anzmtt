import React, { useState } from "react";
import { defaultTheme } from "@/config/theme";
import { Link } from "@inertiajs/react";

export default function ConferencesBlock({
    data,
    conferencesPages = [],
    theme = defaultTheme,
}) {
    const { title, supertitle } = data;

    const limit = 9;
    const hasMoreThanLimit = conferencesPages.length > limit;

    const [expanded, setExpanded] = useState(false);

    const visibleConferences = expanded
        ? conferencesPages
        : conferencesPages.slice(0, limit);

    const formatDate = (date) => {
        if (!date) return null;

        return new Intl.DateTimeFormat("en-GB", {
            day: "numeric",
            month: "short",
            year: "numeric",
        }).format(new Date(date));
    };

    return (
        <section className="flex flex-col gap-8">
            {/* Header */}
            <div className="flex flex-col gap-2 text-center">
                {supertitle && (
                    <h3 className="text-lg text-gray-500">{supertitle}</h3>
                )}

                <h1 className={`text-3xl font-semibold ${theme.text.primary}`}>
                    {title}
                </h1>
            </div>

            {/* Conferences Grid */}
            <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                {visibleConferences.map((conference) => {
                    const backgroundImage =
                        conference.hero?.backgroundImage?.src ?? null;

                    const conferenceDetail = conference.conference;

                    return (
                        <Link
                            key={conference.slug}
                            href={conference.slug}
                            className="group overflow-hidden rounded-xl bg-white shadow transition hover:shadow-lg"
                        >
                            {/* Image */}
                            <div
                                className={`h-48 w-full bg-cover bg-center transition-transform duration-300 group-hover:scale-105 ${theme.bg.secondary}`}
                                style={{
                                    backgroundImage: `url(/storage/${backgroundImage})`,
                                }}
                            />

                            {/* Content */}
                            <div className="flex flex-col gap-2 p-4">
                                <h3
                                    className={`text-lg font-semibold ${theme.text.primary}`}
                                >
                                    {conferenceDetail.full_name}
                                </h3>

                                {conference.subtitle && (
                                    <p className="text-sm text-gray-600 line-clamp-3">
                                        {conference.subtitle}
                                    </p>
                                )}

                                {conferenceDetail.date_from && (
                                    <p
                                        className={`text-sm ${theme.text.primary} line-clamp-3`}
                                    >
                                        {formatDate(conferenceDetail.date_from)}
                                    </p>
                                )}
                            </div>
                        </Link>
                    );
                })}
            </div>

            {/* Footer buttons */}
            {hasMoreThanLimit && (
                <div className="text-center">
                    <button
                        onClick={() => setExpanded((prev) => !prev)}
                        className={`inline-flex items-center px-4 py-2 rounded-lg text-md font-semibold transition-all ${theme.bg.primary} ${theme.text.light} ${theme.bg.hover}`}
                    >
                        {expanded ? "Show less" : "More conferences"}
                    </button>
                </div>
            )}
        </section>
    );
}
