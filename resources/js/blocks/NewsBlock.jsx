import React from "react";
import { defaultTheme } from "@/config/theme";
import { Link } from "@inertiajs/react";

export default function NewsBlock({
    data,
    newsPages = [],
    theme = defaultTheme,
}) {
    const { title, supertitle } = data;

    const latestNews = newsPages.slice(0, 9);

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

            {/* News Grid */}
            <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                {latestNews.map((news) => {
                    const backgroundImage =
                        news.hero?.backgroundImage?.src ?? null;
                    return (
                        <Link
                            key={news.slug}
                            href={`${news.slug}`}
                            className="group overflow-hidden rounded-xl bg-white shadow transition hover:shadow-lg"
                        >
                            {/* Image */}
                            <div
                                className={`h-48 w-full bg-cover bg-center transition-transform duration-300 group-hover:scale-105  ${theme.bg.secondary} `}
                                style={{
                                    backgroundImage: `url(/storage/${backgroundImage})`,
                                }}
                            />

                            {/* Content */}
                            <div className="flex flex-col gap-2 p-4">
                                <h3 className="text-lg font-semibold text-gray-900">
                                    {news.title}
                                </h3>

                                {news.subtitle && (
                                    <p className="text-sm text-gray-600 line-clamp-3">
                                        {news.subtitle}
                                    </p>
                                )}
                            </div>
                        </Link>
                    );
                })}
            </div>

            {/* Footer link */}
            <div className="text-center">
                <Link
                    href="news"
                    className={`inline-flex self-center items-center px-4 py-2 rounded-lg text-md font-semibold transition-all ${theme.bg.primary} ${theme.text.light} ${theme.bg.hover}`}
                >
                    More News
                </Link>
            </div>
        </section>
    );
}
