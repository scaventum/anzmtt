import React, { useState } from "react";
import { Link } from "@inertiajs/react";

import { defaultTheme } from "@/config/theme";

export default function CallForPapersPagesBlock({
    data,
    callForPapersPages = [],
    theme = defaultTheme,
}) {
    const { title, supertitle } = data;

    const limit = 9;
    const hasMoreThanLimit = callForPapersPages.length > limit;

    const [expanded, setExpanded] = useState(false);

    const visiblePages = expanded
        ? callForPapersPages
        : callForPapersPages.slice(0, limit);

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

            {/* Grid */}
            <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                {visiblePages.map((page) => {
                    const backgroundImage =
                        page.hero?.backgroundImage?.src ?? null;

                    console.log(page);

                    const cfp = page.call_for_papers;

                    if (!cfp) return null;

                    return (
                        <Link
                            key={page.slug}
                            href={page.slug}
                            className="group relative overflow-hidden rounded-xl bg-white shadow transition hover:shadow-lg"
                        >
                            {/* Status badge */}
                            <span
                                className={`
                                    absolute right-0 top-0 z-10 rounded-bl-lg
                                    px-3 py-1 text-xs font-bold uppercase tracking-wide text-white
                                    ${
                                        cfp.ongoing
                                            ? "bg-emerald-500"
                                            : "bg-gray-400"
                                    }
                                `}
                            >
                                {cfp.ongoing ? "Ongoing" : "Closed"}
                            </span>

                            {/* Image */}
                            <div
                                className={`
                                    h-48 w-full bg-cover bg-center
                                    transition-transform duration-300
                                    group-hover:scale-105
                                    ${theme.bg.secondary}
                                `}
                                style={{
                                    backgroundImage: backgroundImage
                                        ? `url(/storage/${backgroundImage})`
                                        : undefined,
                                }}
                            />

                            {/* Content */}
                            <div className="flex flex-col gap-3 p-4">
                                <h3
                                    className={`text-lg font-semibold ${theme.text.primary}`}
                                >
                                    {cfp.publication_name}
                                </h3>

                                {cfp.journal && (
                                    <p className="text-sm text-gray-600 line-clamp-2">
                                        {cfp.journal}
                                    </p>
                                )}

                                <div className="flex flex-col gap-1 text-sm text-gray-600">
                                    {(cfp.publication_date_from ||
                                        cfp.publication_date_to) && (
                                        <p>
                                            {formatDate(
                                                cfp.publication_date_from
                                            )}
                                            {cfp.publication_date_to &&
                                                ` – ${formatDate(
                                                    cfp.publication_date_to
                                                )}`}
                                        </p>
                                    )}

                                    {cfp.submission_deadline && (
                                        <p className="font-medium text-gray-700">
                                            Deadline:{" "}
                                            {formatDate(
                                                cfp.submission_deadline
                                            )}
                                        </p>
                                    )}
                                </div>
                            </div>
                        </Link>
                    );
                })}
            </div>

            {/* Footer */}
            {hasMoreThanLimit && (
                <div className="text-center">
                    <button
                        onClick={() => setExpanded((prev) => !prev)}
                        className={`
                            inline-flex items-center
                            px-4 py-2 rounded-lg
                            text-md font-semibold
                            transition-all
                            ${theme.bg.primary}
                            ${theme.text.light}
                            ${theme.bg.hover}
                        `}
                    >
                        {expanded ? "Show less" : "More calls for papers"}
                    </button>
                </div>
            )}
        </section>
    );
}
