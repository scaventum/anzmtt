import React from "react";
import ParagraphBlock from "@blocks/ParagraphBlock.jsx";
import UnorderedListBlock from "@blocks/UnorderedListBlock.jsx";
import NewsBlock from "@blocks/NewsBlock.jsx";
import QuoteBlock from "@blocks/QuoteBlock.jsx";
import ContactBlock from "@blocks/ContactBlock.jsx";
import ErrorBlock from "@blocks/ErrorBlock.jsx";
import { defaultTheme } from "@/config/theme.js";

const BLOCK_COMPONENTS = {
    paragraph: ParagraphBlock,
    unorderedList: UnorderedListBlock,
    news: NewsBlock,
    quote: QuoteBlock,
    contact: ContactBlock,
    error: ErrorBlock,
};

export default function Block({ item, newsPages, theme = defaultTheme }) {
    const { type, data } = item;
    const { background } = data;
    const BlockComponent = BLOCK_COMPONENTS[type];

    let bgColorClass = theme.bg.neutral;
    let textColorClass = theme.text.default;

    if (background === "dark") {
        bgColorClass = theme.bg.secondary;
    } else if (background === "light") {
        bgColorClass = theme.bg.default;
    }

    if (background === "dark") {
        textColorClass = theme.text.light;
    } else if (background === "light") {
        textColorClass = theme.text.default;
    }

    if (!BlockComponent) return null;

    return (
        <section className={`${bgColorClass} ${textColorClass}`}>
            <div
                className={`max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 lg:py-12`}
            >
                <BlockComponent data={data} newsPages={newsPages} />
            </div>
        </section>
    );
}
