import React from "react";
import { Calendar, Link as LinkIcon } from "lucide-react";

import { defaultTheme } from "@/config/theme";
import { Link } from "@inertiajs/react";

export default function CallForPapers({ callForPapers, t = defaultTheme }) {
    if (!callForPapers) return null;

    const formatDate = (date) => {
        if (!date) return null;

        return new Intl.DateTimeFormat("en-GB", {
            day: "numeric",
            month: "short",
            year: "numeric",
        }).format(new Date(date));
    };

    return (
        <section
            className={`
                max-w-7xl mx-auto
                px-4 sm:px-6 lg:px-8
                py-10 lg:py-16
            `}
        >
            <div
                className={`
                    rounded-2xl
                    shadow-sm
                    border
                    ${t.bg.neutral}
                    ${t.text.default}
                    p-6 sm:p-8 lg:p-12
                `}
            >
                {/* Header */}
                <header className="mb-8">
                    <h2
                        className={`
                            text-3xl sm:text-4xl lg:text-5xl
                            font-bold
                            ${t.text.primary}
                            ${t.fontFamily.heading}
                            mb-3
                        `}
                    >
                        {callForPapers.publication_name}
                    </h2>

                    {callForPapers.journal && (
                        <p className="text-lg text-gray-600">
                            {callForPapers.journal}
                        </p>
                    )}

                    <div
                        className={`
                            h-1 w-20
                            rounded
                            ${t.bg.primary}
                            mt-4
                        `}
                    />
                </header>

                {/* Meta grid */}
                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
                    {(callForPapers.publication_date_from ||
                        callForPapers.publication_date_to) && (
                        <MetaItem icon={Calendar} label="Publication Period">
                            {callForPapers.ongoing ? (
                                <span className="font-semibold text-emerald-700">
                                    Ongoing
                                </span>
                            ) : (
                                <>
                                    {formatDate(
                                        callForPapers.publication_date_from
                                    )}
                                    {callForPapers.publication_date_to &&
                                        ` – ${formatDate(
                                            callForPapers.publication_date_to
                                        )}`}
                                </>
                            )}
                        </MetaItem>
                    )}

                    {callForPapers.submission_deadline && (
                        <MetaItem icon={Calendar} label="Submission Deadline">
                            {formatDate(callForPapers.submission_deadline)}
                        </MetaItem>
                    )}

                    {callForPapers.information_link && (
                        <MetaItem icon={LinkIcon} label="More Information">
                            <a
                                href={callForPapers.information_link}
                                target="_blank"
                                rel="noopener noreferrer"
                                className="text-emerald-700 underline underline-offset-4 hover:no-underline"
                            >
                                Visit website
                            </a>
                        </MetaItem>
                    )}
                </div>

                {/* Information */}
                {callForPapers.information && (
                    <div
                        className={`
                            rich
                            max-w-none
                            mb-10
                            ${t.fontFamily.body}
                        `}
                        dangerouslySetInnerHTML={{
                            __html: callForPapers.information,
                        }}
                    />
                )}

                {/* CTA */}
                <div className="flex">
                    <Link
                        href="/contact"
                        rel="noopener noreferrer"
                        className={`
                            inline-flex items-center
                            px-8 py-4
                            rounded-lg
                            text-lg font-semibold
                            ${t.text.light}
                            ${t.bg.primary}
                            ${t.bg.hover}
                            transition
                            focus:outline-none focus:ring-2
                            ${t.focus.primary}
                        `}
                    >
                        Contact us
                    </Link>
                </div>
            </div>
        </section>
    );
}

/**
 * Meta item sub-component
 */
function MetaItem({ icon: Icon, label, children }) {
    return (
        <div className="flex items-start gap-3">
            <Icon className="h-6 w-6 text-emerald-700" />
            <div>
                <span className="text-sm font-semibold text-gray-600">
                    {label}
                </span>
                <p className="text-base text-gray-800">{children}</p>
            </div>
        </div>
    );
}
