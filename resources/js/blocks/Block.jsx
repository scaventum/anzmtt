import React from "react";
import ParagraphBlock from "@blocks/ParagraphBlock";
import UnorderedListBlock from "@blocks/UnorderedListBlock";
import NewsBlock from "@blocks/NewsBlock";
import ConferencesBlock from "@blocks/ConferencesBlock";
import QuoteBlock from "@blocks/QuoteBlock";
import ContactBlock from "@blocks/ContactBlock";
import AccordionBlock from "@blocks/AccordionBlock";
import ErrorBlock from "@blocks/ErrorBlock";
import ExecutiveCommitteeBlock from "@blocks/ExecutiveCommitteeBlock";
import AdvisoryBoardBlock from "@blocks/AdvisoryBoardBlock";
import MemberDirectoryBlock from "@blocks/MemberDirectoryBlock";
import { defaultTheme } from "@/config/theme";

const BLOCK_COMPONENTS = {
    paragraph: ParagraphBlock,
    unorderedList: UnorderedListBlock,
    news: NewsBlock,
    quote: QuoteBlock,
    contact: ContactBlock,
    accordion: AccordionBlock,
    executiveCommittee: ExecutiveCommitteeBlock,
    advisoryBoard: AdvisoryBoardBlock,
    memberDirectory: MemberDirectoryBlock,
    error: ErrorBlock,
    conferences: ConferencesBlock,
};

export default function Block({
    item,
    newsPages,
    conferencesPages,
    executiveCommitteeMembers,
    advisoryBoardMembers,
    members,
    theme = defaultTheme,
}) {
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
                <BlockComponent
                    data={data}
                    newsPages={newsPages}
                    conferencesPages={conferencesPages}
                    executiveCommitteeMembers={executiveCommitteeMembers}
                    advisoryBoardMembers={advisoryBoardMembers}
                    members={members}
                />
            </div>
        </section>
    );
}
